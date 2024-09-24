<?php


namespace App\Services;

use App\Models\Loan;
use App\Repositories\LoanRepositoryInterface;

class LoanService
{
    protected $loanRepository;

    public function __construct(LoanRepositoryInterface $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function getAllLoans()
    {
        return $this->loanRepository->getAllLoans();
    }

    public function getLoanById($loanId)
    {
        return $this->loanRepository->getLoanById($loanId);
    }

    public function createLoan(array $loanData)
    {
        return $this->loanRepository->createLoan($loanData);
    }

    public function updateLoan($loanId, array $loanData)
    {
        return $this->loanRepository->updateLoan($loanId, $loanData);
    }

    public function deleteLoan($loanId)
    {
        return $this->loanRepository->deleteLoan($loanId);
    }
    public function updateLoanStatus($loanId, $status)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->status = $status;
        $loan->save();

        return $loan;
    }
}
