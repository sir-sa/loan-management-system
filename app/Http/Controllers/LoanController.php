<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanCalculationRequest;
use App\Http\Requests\LoanRequest;
use App\Http\Requests\LoanStatusRequest;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index()
    {
        return response()->json($this->loanService->getAllLoans());
    }

    public function show($loanId)
    {
        return response()->json($this->loanService->getLoanById($loanId));
    }

    public function store(LoanRequest $request)
    {
        $loan = $this->loanService->createLoan($request->validated());
        return response()->json($loan, 201);
    }

    public function update(LoanRequest $request, $loanId)
    {
        $loan = $this->loanService->updateLoan($loanId, $request->validated());
        return response()->json($loan);
    }

    public function destroy($loanId)
    {
        $this->loanService->deleteLoan($loanId);
        return response()->json(['message' => 'Loan deleted successfully.'], 200); 
    }

    public function calculateLoan(LoanCalculationRequest $request)
    {
        $principal = $request->input('principal');
        $interestRate = $request->input('interest_rate');
        $loanTermMonths = $request->input('loan_term_months');

        $loanTermYears = $loanTermMonths / 12;

        $totalRepayment = $principal + ($principal * ($interestRate / 100) * $loanTermYears);

        $monthlyRepayment = $totalRepayment / $loanTermMonths;

        return response()->json([
            'total_repayment' => number_format($totalRepayment, 2),
            'monthly_repayment' => number_format($monthlyRepayment, 2),
        ], 200);
    }

    public function updateStatus(LoanStatusRequest $request, $id): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $loan = $this->loanService->updateLoanStatus($id, $validatedData['status']);
            return response()->json([
                'message' => 'Loan status updated successfully.',
                'loan' => $loan,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Loan not found.',
            ], 404);
        }
    }

}
