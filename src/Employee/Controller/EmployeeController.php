<?php

namespace App\Employee\Controller;

use App\Employee\Enum\ResponseMessageEnum;
use App\Employee\Command\CreateEmployeeCommand;
use App\Employee\Command\DeleteEmployeeCommand;
use App\Employee\Command\UpdateEmployeeCommand;
use App\Employee\Query\GetEmployeeQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/** CRUD FOR Employee */
#[Route('/api/employee')]
class EmployeeController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus, private MessageBusInterface $queryBus) {}

    #[Route('', name: 'employee_create', methods: [Request::METHOD_POST])]
    public function create(Request $request): JsonResponse
    {
        $command = new CreateEmployeeCommand($request->request->all());
        try {
            $this->commandBus->dispatch($command);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getPrevious()->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->json([
           'message' => ResponseMessageEnum::COMPANY_CREATED_MESSAGE
        ]);
    }
    #[Route('/{id}', name: 'employee_update', methods: [Request::METHOD_PATCH])]
    public function update(Request $request, int $id): JsonResponse
    {
        $command = new UpdateEmployeeCommand($request->request->all(), $id);
        try {
            $this->commandBus->dispatch($command);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getPrevious()->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->json([
            'message' => ResponseMessageEnum::COMPANY_UPDATED_MESSAGE
        ]);
    }
    #[Route('/{id}', name: 'employee_get', methods: [Request::METHOD_GET])]
    public function get(int $id): JsonResponse
    {
        $query = new GetEmployeeQuery($id);
        /** @var HandledStamp $data */
        $data = $this->queryBus->dispatch($query)->last(HandledStamp::class);
        return $this->json([
            $data->getResult()
        ]);
    }
    #[Route('', name: 'employee_getAll', methods: [Request::METHOD_GET])]
    public function getAll(): JsonResponse
    {
        $query = new GetEmployeeQuery();
        /** @var HandledStamp $data */
        $data = $this->queryBus->dispatch($query)->last(HandledStamp::class);
        return $this->json([
            $data->getResult()
        ]);
    }
    #[Route('/{id}', name: 'employee_delete', methods: [Request::METHOD_DELETE])]
    public function delete(int $id): JsonResponse
    {
        $command = new DeleteEmployeeCommand($id);
        try {
            $this->commandBus->dispatch($command);
        } catch (\Exception $e) {
            return $this->json([
                'message' => $e->getPrevious()->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->json([
            'message' => ResponseMessageEnum::COMPANY_DELETED_MESSAGE
        ]);
    }
}
