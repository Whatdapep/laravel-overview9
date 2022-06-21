<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sm_mem_m_membership_registered extends Model
{
    // use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sm_mem_m_membership_registered';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'MEMBERSHIP_NO';
        /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
}
