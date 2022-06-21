<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\sm_mem_m_membership_registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sm_mem_m_membership_registeredController extends Controller
{
    // เรียกดูเป็นกลุ่ม
    public function index()
    {
        $userdata = sm_mem_m_membership_registered::orderBy("date_of_birth", "asc")->take(15)->get();
        return response()->json($userdata);
    }
    //  ระบุเฉพาะ mem_id
    public function show($id)
    {
        $personaldata = sm_mem_m_membership_registered::find($id);
        return response()->json($personaldata);
    }



    public function deposit_dep_and_withdraw_summary_year(Request $request)
    {
        // dd($request);

        $year = $request->year ?? "2021";
        $deposit = DB::select("SELECT
        DATE_FORMAT(OPERATE_DATE, '%Y-%m') AS MONTH_YEAR,
        COUNT(1) AS count_transaction,
        -- FORMAT(SUM(DEPOSIT_BALANCE), 2) AS sum_deposit_balance,
        -- FORMAT(AVG(DEPOSIT_BALANCE), 2) AS avg_deposit_balance,
        SUM(DEPOSIT_BALANCE) AS sum_deposit_balance,
        AVG(DEPOSIT_BALANCE) AS avg_deposit_balance,
        SIGN_FLAG
    FROM
        sm_dep_m_creditor_item
            JOIN
        sm_dep_m_ucf_dep_item_type ON (sm_dep_m_ucf_dep_item_type.DEPOSIT_ITEM_TYPE = sm_dep_m_creditor_item.ITEM_TYPE)
    WHERE
        1 AND SIGN_FLAG = 1
            AND DATE_FORMAT(OPERATE_DATE, '%Y') = '" . $year . "'
    GROUP BY DATE_FORMAT(OPERATE_DATE, '%Y-%m') , SIGN_FLAG
    ORDER BY DATE_FORMAT(OPERATE_DATE, '%Y-%m') ASC
    ;");

        $withdraw = DB::select("SELECT
    DATE_FORMAT(OPERATE_DATE, '%Y-%m') AS MONTH_YEAR,
    COUNT(1) AS count_transaction,
    -- FORMAT(SUM(DEPOSIT_BALANCE), 2) AS sum_deposit_balance,
    -- FORMAT(AVG(DEPOSIT_BALANCE), 2) AS avg_deposit_balance,
    SUM(DEPOSIT_BALANCE) AS sum_deposit_balance,
    AVG(DEPOSIT_BALANCE) AS avg_deposit_balance,
    SIGN_FLAG
FROM
    sm_dep_m_creditor_item
        JOIN
    sm_dep_m_ucf_dep_item_type ON (sm_dep_m_ucf_dep_item_type.DEPOSIT_ITEM_TYPE = sm_dep_m_creditor_item.ITEM_TYPE)
WHERE
    1 AND SIGN_FLAG = -1
        AND DATE_FORMAT(OPERATE_DATE, '%Y') = '" . $year . "'
GROUP BY DATE_FORMAT(OPERATE_DATE, '%Y-%m') , SIGN_FLAG
ORDER BY DATE_FORMAT(OPERATE_DATE, '%Y-%m') ASC
;");

        return response()->json(["deposit" => $deposit, "withdraw" => $withdraw]);
    }




}
