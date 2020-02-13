<?php


namespace App\Http\Controllers;

use App\Repository\UserSellerRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UsersSellersController extends Controller
{
    /**
     * @var UserSellerRepository
     */
    protected $sellerRepository;

    public function __construct(UserSellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request) :Response
    {
        $response = [];
        try {
            $data = $this->validate($request, [
                'user_id' => 'required|exists:users,id|unique:users_sellers,user_id',
                'cnpj' => 'required',
                'fantasy_name' => 'required',
                'social_name' => 'required',
                'username' => 'required|unique:users_consumers,username|unique:users_sellers,username'
            ]);
            $status = 201;
            $response = $this->sellerRepository->save($data);
        } catch (ValidationException $validationException) {
            $errors = $validationException->errors();
            $status = isset($errors['user_id']) ? 404 : 422;
            $response['message'] = $errors;
        } catch (\Throwable $e) {
            $status = 500;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response, $status);
    }
}