<?php

namespace App\Http\Middleware;

use App\Models\ExtraInformation;
use App\Models\SectionFive;
use App\Models\SectionFour;
use Closure;
use Illuminate\Http\Request;

class SectFive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $progress = ExtraInformation::where('user_id', auth()->id())->where('status', '!=', 'HOD reviewed')->latest()->first();
        $progress->load('sectionFour');
        if ($progress->sectionFour->sup_needs_improvement != '') {
            return $next($request);
        }
        abort(403,'you must complete the previous section');
    }
}
