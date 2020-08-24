<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseMessages;
use App\Helpers\SlipHelper;
use App\Http\Requests\GameRequest;
use App\Http\Requests\SlipRequest;
use App\Models\Slip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlipController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getSlip(Request $request)
    {
        $slipId = $request->core_session->get('slip_id');
        $slip = Slip::getById($slipId);

        return $this->sendSuccess($slip->toArray(), 'Slip retrieved successfully');
    }

    /**
     * @param SlipRequest $request
     * @return Response
     * @throws CustomException
     */
    public function modifySlip(SlipRequest $request)
    {
        $slipId = \request()->core_session->get('slip_id');
        $slip = SlipHelper::modifySlip($slipId, $request->validated());

        if (is_array($slip)) {
            return $this->processError($slip);
        }

        return $this->processResponse($slip);
    }

    /**
     * @param Slip $slip
     * @return Response
     * @throws \Exception
     */
    public function delete(Slip $slip)
    {
        $slip->delete();
        \request()->core_session->remove(['slip_id']);

        return $this->sendSuccess([],'Slip deleted successfully');
    }

    /**
     * @param Slip $slip
     * @param array $additionalData
     * @return Response
     */
    protected function processResponse(Slip $slip, array $additionalData = [])
    {
        $response = [];
        $slipArray = $slip->toArray();
        $slipArray['slip_items'] = $slip->slipItems->toArray();

        $response['slip'] = $slipArray;
        if ($slip->user) {
            $response['user'] = $slip->user->toArray();
        } else {
            $response['user'] = [];
        }

        foreach ($additionalData as $key => $value) {
            $response[$key] = $value;
        }

        return $this->sendSuccess($response);
    }

    /**
     * Display the specified resource.
     *
     * @param Slip $slip
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function checkout(Slip $slip, GameRequest $request)
    {
//        dd();
        if (!$slip->user_id) {
            return $this->sendError(
                ResponseMessages::USER_NOT_LOGGED_IN,
                ResponseCodes::USER_NOT_LOGGED_IN);
        }
        $game = SlipHelper::convertSlipToGame($slip, $request->validated());
//        dd($game);
        $slip = SlipHelper::deleteSlip($slip, $slip->user, true);
        \request()->core_session->set('slip_id', $slip->id);

        return $this->sendSuccess($game->fresh()->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slip  $slip
     * @return Response
     */
    public function update(Request $request, Slip $slip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slip  $slip
     * @return Response
     */
    public function destroy(Slip $slip)
    {
        //
    }
}
