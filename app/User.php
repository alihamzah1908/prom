<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function userRole()
    {
        return $this->role_id;
    }
    public function role()
    {
        return $this->belongsTo('\App\Model\Roles', 'role_id');
    }
    public function getUserRole($route){
        $role = \App\Model\Roles::where('id_role', $this->role_id)->first();
        
        $access = "UNAUTHORIZED";
        if($role){
            // $web_access = '["role_test","home"]';
            $web_access = json_decode($role->web_access);
            if(in_array("/".$route->uri, $web_access)){
                $access = "AUTHORIZED";
            }
        }
        if($role->role_name == "ADMIN"){
            $access = "AUTHORIZED";
        }
        
        $n_access = is_admin(\Auth::user());
        if($n_access){
            $access = "AUTHORIZED";
        }
        // $access = "AUTHORIZED";
        return $access;
    }
    public function getAccessList($route){
        $role = \App\Model\Roles::where('id_role', $this->role_id)->first();
        $access = json_decode($role->web_access);
        if(in_array("/".$route->uri, $access)){
            $access = "AUTHORIZED";
        }
        // array_push($access, $route->uri);
        return $access;
    }
    public function getMyAccessList(){
        $role = \App\Model\Roles::where('id_role', $this->role_id)->first();
        return $role->web_access;
    }
    public function getAccess($to){
        // return true;
        $access = $this->getMyAccessList();
        $access = json_decode($access);
        
        if($this->role_id == 1){
            return true;
        }
        
        if(in_array($to, $access)){
            return true;
        }
        $n_access = is_admin(\Auth::user());
        if($n_access){
            return true;
        }
        return false;
    }
    public function hasRole($roles, $route)
    {
        $this->have_role = $this->getUserRole($route);
        
        if(is_array($roles)){
            foreach($roles as $need_role){
                if($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else{
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }
 
    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role)==strtolower($this->have_role)) ? true : false;
    }
    
    public function getRole()
    {
        return $this->belongsTo('\App\Model\Roles', 'role_id');
    }
    public function getDepartement()
    {
        return $this->belongsTo('\App\Model\Departement', 'departement_id');
    }
}
