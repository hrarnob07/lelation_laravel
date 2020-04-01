<?php
/**
 * Query filters
 * php version 7.1
 *
 * @category Eloquent
 * @package  Clinker
 * @author   softzino
 * @license  
 */
namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
/**
 * Users filters
 *
 * @category Eloquent
 * @package  bdgym
 * @author   
 * @license  
 * @link     
 */
class UserFilters extends Filter
{
    /**
     * User filter by status
     *
     * @param string $status user status
     *
     * @return Builder
     */
    public function status(Builder $query, string $status = 'active')
    {
        return $query->where('status', $status);
    }

    /**
     * User filter by company ID
     *
     * @param int $id company user id
     *
     * @return Builder
     */
    public function companyId(Builder $query, int $id = 0)
    {
        if (empty($id)) {
            return $query;
        }
        if($id == '-1') {
            return $query->doesntHave('companies');
        }
        return $query->whereHas(
            'companies',
            function ($query) use ($id) {
                return $query->where('company_id', $id);
            }
        );
    }


}
