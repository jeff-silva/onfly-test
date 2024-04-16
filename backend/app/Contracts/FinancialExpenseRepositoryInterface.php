<?php

namespace App\Contracts;

interface FinancialExpenseRepositoryInterface
{
    public function index($data);
    public function store($data);
    public function show($id);
    public function update($data, $id);
    public function destroy($id);
}
