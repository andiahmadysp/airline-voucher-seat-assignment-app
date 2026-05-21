<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckVoucherRequest;
use App\Http\Requests\GenerateVoucherRequest;
use App\Http\Resources\VoucherCheckResource;
use App\Http\Resources\VoucherResource;
use App\Services\VoucherAssignmentService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct(
        private readonly VoucherAssignmentService $voucher,
    ) {}

    public function check(CheckVoucherRequest $request): VoucherCheckResource
    {
        $exists = $this->voucher->isAlreadyAssigned(
            $request->flightNumber,
            $request->date,
        );

        return new VoucherCheckResource($exists);
    }

    public function generate(GenerateVoucherRequest $request): VoucherResource
    {
        $seats = $this->voucher->assign($request->validated());

        return new VoucherResource($seats);
    }
}
