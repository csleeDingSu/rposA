<?php
namespace App;
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{   
    protected $fillable = [
        'username',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'members';
	
	public function save_member()
	{
		
		return redirect()->route('your_url_where_you_want_to_redirect');
	}
}