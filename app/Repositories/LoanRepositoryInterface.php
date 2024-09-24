<?php

namespace App\Repositories;

use App\Models\Loan;

interface LoanRepositoryInterface
{
    public function getAllLoans();
    public function getLoanById($loanId);
    public function createLoan(array $loanData);
    public function updateLoan($loanId, array $loanData);
    public function deleteLoan($loanId);
}