<?php

namespace App\Company\Controller;

use App\Company\Command\CreateCompanyCommand;
use App\Company\Command\DeleteCompanyCommand;
use App\Company\Command\UpdateCompanyCommand;
use App\Company\Enum\ResponseMessageEnum;
use App\Company\Query\GetCompanyQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/** CRUD FOR Company */
#[Route('/api/company')]
class CompanyController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus, private MessageBusInterface $queryBus) {}

    #[Route('', name: 'company_create', methods: [Request::METHOD_POST])]
    public function create(Request $request): JsonResponse
    {
        $command = new CreateCompanyCommand($request->request->all());
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
    #[Route('/{id}', name: 'company_update', methods: [Request::METHOD_PATCH])]
    public function update(Request $request, int $id): JsonResponse
    {
        $command = new UpdateCompanyCommand($request->request->all(), $id);
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
    #[Route('/{id}', name: 'company_get', methods: [Request::METHOD_GET])]
    public function get(int $id): JsonResponse
    {
        $query = new GetCompanyQuery($id);
        /** @var HandledStamp $data */
        $data = $this->queryBus->dispatch($query)->last(HandledStamp::class);
        return $this->json([
            $data->getResult()
        ]);
    }
    #[Route('', name: 'company_getAll', methods: [Request::METHOD_GET])]
    public function getAll(): JsonResponse
    {
        $query = new GetCompanyQuery();
        /** @var HandledStamp $data */
        $data = $this->queryBus->dispatch($query)->last(HandledStamp::class);
        return $this->json([
            $data->getResult()
        ]);
    }
    #[Route('/{id}', name: 'company_delete', methods: [Request::METHOD_DELETE])]
    public function delete(int $id): JsonResponse
    {
        $command = new DeleteCompanyCommand($id);
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
