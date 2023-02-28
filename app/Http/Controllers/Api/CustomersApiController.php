<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0.0', title: 'Customers API', description: 'Customers API')]
#[OA\Server(description: 'Customers API Server', url: 'http://localhost:8080/api/customers'), OA\Contact('hej')]
#[OA\Components(
    schemas: [
        new OA\Schema(
            type: 'object',
            schema: 'Customer',
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'firstName', type: 'string'),
                new OA\Property(property: 'lastName', type: 'string'),
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'phoneNumber', type: 'string'),
                new OA\Property(property: 'street', type: 'string'),
                new OA\Property(property: 'houseNumber', type: 'string'),
                new OA\Property(property: 'postCode', type: 'string'),
                new OA\Property(property: 'city', type: 'string'),
                new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
                new OA\Property(property: 'updated_at', type: 'string', format: 'date-time')
            ]
        )
    ]
)]
class CustomersApiController extends Controller
{
    public function __construct(private CustomerService $customers)
    {
    }
    /**
     * Display a listing of the resource.
     * @return \App\Http\Resources\CustomerCollection
     */
    #[OA\Get(
        path: '/',
        operationId: 'listCustomers',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of customers',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'array',
                        items: new OA\Items(ref: '#/components/schemas/Customer')
                    )
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Filter error',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'errors', type: 'object', properties: [
                                new OA\Property(property: 'message', type: 'string')
                            ])
                        ]
                    )
                )
            )
        ],
        tags: ['customers']
    )]
    public function index()
    {
        return $this->customers->list();
    }

    /**
     * Store a newly created resource in storage.
     * @return \App\Http\Resources\CustomerResource
     */
    #[OA\Post(
        path: '/',
        operationId: 'addCustomer',
        requestBody: new OA\RequestBody(
            description: 'Update properties',
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/Customer'
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Customer added',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        ref: '#/components/schemas/Customer'
                    )
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'message', type: 'object'),
                            new OA\Property(property: 'errors', type: 'object')
                        ]
                    )
                )
            )

        ],
        tags: ['customers']
    )]
    public function store(Request $request)
    {
        return $this->customers->store($request->all());
    }

    /**
     * Display the specified resource.
     * @return \App\Http\Resources\CustomerResource
     */
    #[OA\Get(
        path: '/{customerId}',
        operationId: 'showCustomer',
        parameters: [
            new OA\Parameter(name: 'customerId', in: 'path', required: true),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Customer showed',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        ref: '#/components/schemas/Customer'
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Record not found',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'errors', type: 'object', properties: [
                                new OA\Property(property: 'message', type: 'string')
                            ])
                        ]
                    )
                )
            )
        ],
        tags: ['customers']
    )]
    public function show(Customer $customer)
    {
        return $this->customers->show($customer);
    }

    /**
     * Update the specified resource in storage.
     * @return \App\Http\Resources\CustomerResource
     */
    #[OA\Patch(
        path: '/{customerId}',
        operationId: 'updateCustomer',
        parameters: [
            new OA\Parameter(name: 'customerId', in: 'path', required: true),
        ],
        requestBody: new OA\RequestBody(
            description: 'Update properties',
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/Customer'
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Customer updated',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        ref: '#/components/schemas/Customer'
                    )
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'message', type: 'object'),
                            new OA\Property(property: 'errors', type: 'object')
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Record not found',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'errors', type: 'object', properties: [
                                new OA\Property(property: 'message', type: 'string')
                            ])
                        ]
                    )
                )
            )

        ],
        tags: ['customers']
    )]
    public function update(Request $request, Customer $customer)
    {
        return $this->customers->update($request->all(), $customer);
    }

    /**
     * Remove the specified resource from storage.
     * @return void
     */
    #[OA\Delete(
        path: '/{customerId}',
        operationId: 'deleteCustomer',
        parameters: [
            new OA\Parameter(name: 'customerId', in: 'path', required: true),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Customer deleted'),
            new OA\Response(
                response: 404,
                description: 'Record not found',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(property: 'errors', type: 'object', properties: [
                                new OA\Property(property: 'message', type: 'string')
                            ])
                        ]
                    )
                )
            )
        ],
        tags: ['customers']
    )]
    public function destroy(Customer $customer)
    {
        $this->customers->destroy($customer);
    }
}
