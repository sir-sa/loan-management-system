<?php

namespace App\Repositories;

use App\Models\Loan;

class LoanRepository implements LoanRepositoryInterface
{
    protected $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function getAllLoans()
    {
        return $this->loan->all();
    }

    public function getLoanById($loanId)
    {
        return $this->loan->findOrFail($loanId);
        
    }

    public function createLoan(array $loanData)
    {
        return $this->loan->create($loanData);
    }

    public function updateLoan($loanId, array $loanData)
    {
        $loan = $this->getLoanById($loanId);
        $loan->update($loanData);
        return $loan;
    }

    public function deleteLoan($loanId)
    {
        $loan = $this->getLoanById($loanId);
        return $loan->delete();
    }
}
