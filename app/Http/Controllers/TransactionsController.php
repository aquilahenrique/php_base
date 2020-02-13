<?php

namespace App\Http\Controllers;

use App\Repository\TransactionRepository;
use App\Service\Payment\AuthorizationInterface;
use App\Service\PaymentAuthorization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TransactionsController extends Controller
{
    /**
     * @var TransactionRepository
     */
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function create(Request $request) :Response
    {
        $response = [];
        try {
            $data = $this->validate($request, [
                'payee_id' => 'required|exists:users,id',
                'payer_id' => 'required|exists:users,id|different:payee_id',
                'value' => 'required'
            ]);
            $status = 201;

            $response = $this->transactionRepository->save($data);

        } catch (\DomainException $domainException){
            $status = 401;
            $response['message'] = $domainException->getMessage();
        } catch (ValidationException $validationException) {
            $status = 422;
            $response['message'] = $validationException->errors();
        } catch (\Throwable $e) {
            $status = 500;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response, $status);
    }

    public function show($id) :Response
    {
        $response = [];
        try {
            $status = 201;
            $response = $this->transactionRepository->find($id);
            if (null == $response) {
                throw new \DomainException('User not found');
            }
        } catch (\DomainException $domainException){
            $status = 404;
            $response['message'] = $domainException->getMessage();
        } catch (\Throwable $e) {
            $status = 500;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response, $status);
    }
}
