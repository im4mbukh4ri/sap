<?php

namespace App\Helpers;

use App\Helpers\Charity\CharityTransaction;

/**
 *
 */
class SipCharity {

	public static function TransferCharity($userId, $charityId, $nominal) {
		$charity = new CharityTransaction($userId, $charityId, $nominal);
		return $charity->doTransfer();
	}
}