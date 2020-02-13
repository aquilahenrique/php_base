<?php


namespace App\Http\Controllers;


use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
                'cpf' => 'required|unique:users,cpf',
                'email' => 'required|email|unique:users,email',
                'full_name' => 'required',
                'password' => 'required',
                'phone_number' => 'required'
            ]);
            $status = 201;
            $response = $this->userRepository->save($data);
        } catch (ValidationException $validationException) {
            $status = 422;
            $response['message'] = $validationException->errors();
        } catch (\Throwable $e) {
            $status = 500;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response, $status);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) :Response
    {
        $response = [];
        try {
            $status = 201;
            $query = $request->get('q');

            // Checking that it's not path, because nginx is configured with q param
            if (null !== $query && $query != '/users') {
                $response = $this->userRepository->findByName($query);
                return response()->json($response, $status);
            }
            $response = $this->userRepository->findAll();
        } catch (\Throwable $e) {
            $status = 500;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response, $status);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function show(Request $request, $id) :Response
    {
        $response = [];
        try {
            $status = 201;
            $response = $this->userRepository->findWithAccounts($id);
        } catch (\DomainException $domainException) {
            $status = 404;
            $response['message'] = $domainException->getMessage();
        } catch (\Throwable $e) {
            $status = 500;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response, $status);
    }
}