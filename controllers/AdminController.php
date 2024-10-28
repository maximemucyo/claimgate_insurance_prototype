<?php

require_once dirname(__DIR__, 2) . '/config/db.php';

class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to fetch all claims for the admin dashboard
    public function getAllClaims() {
        $stmt = $this->pdo->prepare('SELECT * FROM claims');
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
        header('Location: /ClaimGate/views/admin/admin_dashboard.php');
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
}
?>
