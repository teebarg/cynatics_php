<?php

namespace App\Http\Controllers;

use App\Models\SlipItem;
use Illuminate\Http\Response;

class SlipItemController extends BaseController
{
    /**
     * Remove the specified resource from storage.
     *
     * @param SlipItem $slipItem
     * @return Response
     * @throws \Exception
     */
    public function destroy(SlipItem $slipItem)
    {
        $slipItem->delete();

        return $this->sendSuccess([],'SlipItem deleted successfully');
    }
}
