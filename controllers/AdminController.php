<?php

//require_once '../middleware/auth.php';

class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->prepare('SELECT * FROM users');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Method to fetch all claims for the admin dashboard
    public function getAllClaims() {
        $stmt = $this->pdo->prepare('SELECT * FROM claims');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // Method to fetch all assessors for the admin dashboard
     public function getAllAssesors() {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE role="assessor"');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get a specific claim by ID
    public function getClaimById($claimId) {
        $stmt = $this->pdo->prepare('SELECT * FROM claims WHERE id = :id');
        $stmt->execute([':id' => $claimId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to update the claim status
    public function updateClaimStatus($claimId, $status) {
        $stmt = $this->pdo->prepare('UPDATE claims SET status = :status WHERE id = :id');
        $stmt->execute([':status' => $status, ':id' => $claimId]);

        // Add timeline entry for status change
        $this->addTimelineEvent($claimId, date('Y-m-d H:i:s'), "Claim $status by Admin");

        // Redirect back to the admin dashboard
        header('Location: /ClaimGate/views/admin/index.php');
        exit;
    }

    // Method to add timeline events for the claim
    public function addTimelineEvent($claimId, $date, $description) {
        $stmt = $this->pdo->prepare("
            INSERT INTO claim_timeline (claim_id, date, description, completed)
            VALUES (:claim_id, :date, :description, 1)
        ");
        $stmt->execute([
            'claim_id' => $claimId,
            'date' => $date,
            'description' => $description
        ]);
    }

    // Method to assign assessor to claim
    public function assignAssessor($claimId, $assessor_id) {
        try {
            $stmt = $this->pdo->prepare('UPDATE claims SET assessor_id = :assessor_id WHERE id = :id');
            $stmt->execute([':assessor_id' => $assessor_id, ':id' => $claimId]);
    
            // Add timeline entry for assessor assignment
            $this->addTimelineEvent($claimId, date('Y-m-d H:i:s'), "Claim assigned to $assessor_id by Admin");
    
            // $response = [
            //     'status' => 'success',
            //     'message' => 'Assessor assigned successfully.',
            //     'claimId' => $claimId,
            //     'assessorId' => $assessor_id,
            // ];
            
            // return json_encode($response);
            header('Location: /ClaimGate/views/admin/index.php');
        } catch (PDOException $e) {

            error_log($e->getMessage());
    
            $response = [
                'status' => 'error',
                'message' => 'Failed to assign assessor: ' . $e->getMessage(),
            ];
            
            return json_encode($response);
        }
    }
    
}
?>
