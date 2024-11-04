<?php
// require_once '../middleware/auth.php';

class ClaimController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function submitClaim() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect form data
            $userId = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            $policyholderName = $_POST['policyholder_name'];
            $incidentType = $_POST['incident_type'];
            $description = $_POST['description'];
            $thirdPartyName = !empty($_POST['third_party_name']) ? $_POST['third_party_name'] : null;
            $thirdPartyInfo = !empty($_POST['third_party_info']) ? $_POST['third_party_info'] : null;

            // Handle file uploads with improved naming
            $insuranceCertificate = $this->handleFileUpload('insurance_certificate', $username, 'InsuranceCertificate');
            $drivingLicense = $this->handleFileUpload('driving_license', $username, 'DrivingLicense');
            $logBook = $this->handleFileUpload('log_book', $username, 'Logbook');
            $policeReport = $this->handleFileUpload('police_report', $username, 'PoliceReport');
            $damageEstimate = $this->handleFileUpload('damage_estimate', $username, 'DamageEstimate');
            $claimFile = $this->handleFileUpload('claim_file', $username, 'ClaimSupportingFile');

            // Check if any required file is missing
            if (!$insuranceCertificate || !$drivingLicense || !$logBook || !$policeReport || !$claimFile) {
                echo "Error: Required files are missing. Please ensure all required files are uploaded.";
                return;
            }

            // Insert claim into the database
            try {
                $stmt = $this->pdo->prepare("
                    INSERT INTO claims (
                        user_id, policyholder_name, incident_type, description, 
                        insurance_certificate, driving_license, log_book, 
                        police_report, damage_estimate, third_party_name, 
                        third_party_info, claim_file
                    ) VALUES (
                        :user_id, :policyholder_name, :incident_type, :description, 
                        :insurance_certificate, :driving_license, :log_book, 
                        :police_report, :damage_estimate, :third_party_name, 
                        :third_party_info, :claim_file
                    )
                ");
                $stmt->execute([
                    'user_id' => $userId,
                    'policyholder_name' => $policyholderName,
                    'incident_type' => $incidentType,
                    'description' => $description,
                    'insurance_certificate' => $insuranceCertificate,
                    'driving_license' => $drivingLicense,
                    'log_book' => $logBook,
                    'police_report' => $policeReport,
                    'damage_estimate' => $damageEstimate,
                    'third_party_name' => $thirdPartyName,
                    'third_party_info' => $thirdPartyInfo,
                    'claim_file' => $claimFile
                ]);

                $claimId = $this->pdo->lastInsertId();

                // Add initial timeline event
                $this->addTimelineEvent($claimId, date('Y-m-d H:i:s'), 'Claim submitted', true);

                // Redirect or show success message
                echo "Claim submitted successfully!";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    // Updated method for handling file uploads with improved naming convention
    private function handleFileUpload($fieldName, $username, $docType) {
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] == UPLOAD_ERR_OK) {
            $targetDirectory = '../assets/uploads/';
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            // Generate a unique filename using username, document type, and current timestamp
            $fileExtension = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
            $uniqueName = $username . '-' . $docType . '-' . date('Ymd_His') . '.' . $fileExtension;
            $targetFile = $targetDirectory . $uniqueName;

            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $targetFile)) {
                return $targetFile;
            } else {
                echo "Error: Failed to upload " . htmlspecialchars($_FILES[$fieldName]['name']) . ".<br>";
            }
        } else {
            echo "Error: No file uploaded or an error occurred for " . htmlspecialchars($fieldName) . ".<br>";
        }
        return null;
    }

    // Method to fetch claim details for a user
    public function getClaim($userId) {
        // Fetch the main claim details for the user
        $stmt = $this->pdo->prepare("
            SELECT * FROM claims WHERE user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        $claim = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($claim) {
            // Fetch the timeline events for this claim
            $timelineStmt = $this->pdo->prepare("
                SELECT date, description, completed FROM claim_timeline WHERE claim_id = :claim_id ORDER BY date ASC
            ");
            $timelineStmt->execute(['claim_id' => $claim['id']]);
            $claim['timeline'] = $timelineStmt->fetchAll(PDO::FETCH_ASSOC); // Fetch timeline as associative array
        }

        return $claim;
    }

    public function getClaimById($claimId, $userId) {
        // Fetch the main claim details for the specific claim and user
        $stmt = $this->pdo->prepare("
            SELECT * FROM claims WHERE id = :claim_id AND user_id = :user_id
        ");
        $stmt->execute(['claim_id' => $claimId, 'user_id' => $userId]);
        $claim = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($claim) {
            // Fetch the timeline events for this claim
            $timelineStmt = $this->pdo->prepare("
                SELECT date, description, completed FROM claim_timeline WHERE claim_id = :claim_id ORDER BY date ASC
            ");
            $timelineStmt->execute(['claim_id' => $claim['id']]);
            $claim['timeline'] = $timelineStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $claim;
    }

    public function addTimelineEvent($claimId, $date, $description, $completed = false) {
        $stmt = $this->pdo->prepare("
            INSERT INTO claim_timeline (claim_id, date, description, completed) VALUES (:claim_id, :date, :description, :completed)
        ");
        $stmt->execute([
            'claim_id' => $claimId,
            'date' => $date,
            'description' => $description,
            'completed' => $completed
        ]);
    }

    public function getApprovedGarages() {
        $stmt = $this->pdo->prepare("SELECT * FROM garages WHERE approved = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

      // Method to fetch all claims for the admin dashboard
      public function getClaimsByUser($userId) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM claims WHERE user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bidClaim($claimId, $userId, $amount) {
        $stmt = $this->pdo->prepare("
            INSERT INTO bids (claim_id, user_id, amount) VALUES (:claim_id, :user_id, :amount)
        ");
        $stmt->execute([
            'claim_id' => $claimId,
            'user_id' => $userId,
            'amount' => $amount,
        ]);
    }

    public function hasBidSubmitted($claimId, $userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM bids WHERE claim_id = :claim_id AND user_id = :user_id");
        $stmt->execute([
            'claim_id' => $claimId,
            'user_id' => $userId,
        ]);
        $bidCount = $stmt->fetchColumn();
        return $bidCount > 0;
    }

    public function getBidsByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM bids WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
