<?php

namespace App\Services;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerService {
    /**
     * 
     * https://spatie.be/docs/laravel-query-builder/v5/
     * @return CustomerCollection
     */
    public function list () 
    {
        $maxPageSize = 50;
        $allowedApiFilters = [
            'firstName', 'lastName', 'email', 'phoneNumber',
            'street', 'houseNumber', 'postCode', 'city'
        ];

        $customers = QueryBuilder::for(Customer::class)
            ->allowedFilters($allowedApiFilters)
            ->jsonPaginate($maxPageSize);

        return new CustomerCollection($customers);
    }

    /**
     * Undocumented function
     *
     * @param array<string> $customerData
     * @return CustomerResource
     */
    public function store (array $customerData) 
    {
        $validator = Validator::make($customerData, [
            'firstName'     => 'required|max:255',
            'lastName'      => 'required|max:255',
            'email'         => 'required|max:255|unique:customers',
            'phoneNumber'   => 'required|max:255',
            'street'        => 'required|max:255',
            'houseNumber'   => 'required|max:255',
            'postCode'      => 'required|max:255',
            'city'          => 'required|max:255'
        ]);

        $validator->validate();

        $customer = Customer::create($validator->validated());

        return new CustomerResource($customer);
    }

    /**
     * Undocumented function
     *
     * @param Customer $customer
     * @return CustomerResource
     */
    public function show (Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Undocumented function
     *
     * @param array<string> $customerData
     * @param Customer $customer
     * @return CustomerResource
     */
    public function update(array $customerData, Customer $customer) 
    {
        $validator = Validator::make($customerData, [
            'firstName'     => 'max:255',
            'lastName'      => 'max:255',
            'email'         => 'max:255|unique:customers',
            'phoneNumber'   => 'max:255',
            'street'        => 'max:255',
            'houseNumber'   => 'max:255',
            'postCode'      => 'max:255',
            'city'          => 'max:255'
        ]);

        $validator->validate();

        $customer->update($validator->validated());

        return new CustomerResource($customer);
    }

    /**
     * Undocumented function
     *
     * @param Customer $customer
     * @return void
     */
    public function destroy(Customer $customer) 
    {
        $customer->delete();
    }
}
