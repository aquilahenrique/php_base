<?php


namespace App\Http\Controllers;


use App\Repository\UserConsumerRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UsersConsumersController extends Controller
{
    /**
     * @var UserConsumerRepository
     */
    protected $consumerRepository;

    public function __construct(UserConsumerRepository $consumerRepository)
    {
        $this->consumerRepository = $consumerRepository;
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
                'user_id' => 'required|exists:users,id|unique:users_consumers,user_id',
                'username' => 'required|unique:users_consumers,username|unique:users_sellers,username'
            ]);
            $status = 201;
            $response = $this->consumerRepository->save($data);
        } catch (ValidationException $validationException) {
            $errors = $validationException->errors();
            $status = $errors['user_id'] ? 404 : 422;
            $response['message'] = $errors;
        } catch (\Throwable $e) {
            $status = 500;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response, $status);
    }
}