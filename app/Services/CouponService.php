<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Facades\Log;

class CouponService
{
    public function getCoupon($code)
    {
        $coupon = Coupon::firstWhere('code', $code);
        return $this->checkValidity($coupon) ? $coupon : null;
    }

    public function find($id)
    {
        $coupon = Coupon::find($id);
        return $this->checkValidity($coupon) ? $coupon : null;
    }

    public function getDiscount($coupon, $orderAmount)
    {
        $discount = $coupon->value;

        if ($coupon->type === 'percent') {
            $discount = $orderAmount * ($coupon->value / 100);
            if ($discount > $coupon->max_amount) {
                $discount = $coupon->max_amount;
            }

            if ($discount < $coupon->min_amount) {
                $discount = $coupon->min_amount;
            }
        }

        return round($discount, 2);
    }

    public function checkValidity($coupon, $orderAmount = null)
    {
        if (!$coupon || !$coupon->active) {
            return false;
        }

        $now = now();

        if ($now->lte($coupon->starting_time) || $now->gte($coupon->ending_time)) {
            return false;
        }

        if ($orderAmount) {
            if ($orderAmount < $coupon->min_amount) {
                return false;
            }

            if ($coupon->max_amount && $orderAmount > $coupon->max_amount) {
                return false;
            }
        }


        return true;
    }
}
