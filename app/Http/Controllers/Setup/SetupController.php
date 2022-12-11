<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Segment;
use \App\Model\Shelf;
use \App\Model\Slot;
use \App\Model\Port;
use \App\Model\CID;

class SetupController extends Controller
{
    public function index()
    {
        $data['title'] = 'Setup';
        return view('setup.index', $data);
    }
    public function servicedesk()
    {
        $title['title'] = 'servicedesk';
        $header_title['header_title'] = 'Servicedesk Configurations';
        return view('setup.servicedesk.index', $title, $header_title);
    }
    public function userpermission()
    {
        $title['title'] = 'user permission';
        $header_title['header_title'] = 'User & Permissions';
        return view('setup.userpermission.index', $title, $header_title);
    }
    public function detailrole()
    {
        $title['title'] = 'user permission';
        $header_title['header_title'] = 'User & Permissions';
        return view('setup.userpermission.detail_role', $title, $header_title);
    }
    public function notif()
    {
        $title['title'] = 'Notif Setting';
        $header_title['header_title'] = 'Notif Settings';
        return view('setup.notif_setting.index', $title, $header_title);
    }
    public function templateForm()
    {
        $title['title'] = 'Template Form';
        $header_title['header_title'] = 'Template Form';
        return view('setup.template_form.index', $title, $header_title);
    }
    public function Customization()
    {
        $title['title'] = 'Customization';
        $header_title['header_title'] = 'Customization';
        return view('setup.customization.index', $title, $header_title);
    }
    public function CustomizationDetail()
    {
        $title['title'] = 'Customization';
        $header_title['header_title'] = 'Customization';
        return view('setup.customization.detail', $title, $header_title);
    }
    public function administration()
    {
        $title['title'] = 'administration';
        $header_title['header_title'] = 'administration';
        return view('setup.administration.index', $title, $header_title);
    }
    public function chat()
    {
        $title['title'] = 'chat';
        $header_title['header_title'] = 'chat';
        return view('setup.chat.index', $title, $header_title);
    }
    public function getSegment(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_segment';
        $order_dir = 'ASC';
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }
        $data = Segment::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_segment', 'segment_name')->original;
        return response()->json($result);
    }
    public function getShelf(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_shelf';
        $order_dir = 'ASC';
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }
        $data = Shelf::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_shelf', 'name_shelf')->original;
        return response()->json($result);
    }
    public function getSlot(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_slot';
        $order_dir = 'ASC';
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }
        $data = Slot::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_slot', 'name_slot')->original;
        return response()->json($result);
    }
    public function getPort(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_port';
        $order_dir = 'ASC';
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }
        $data = Port::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_port', 'port_name')->original;
        return response()->json($result);
    }
    public function getCid(Request $r){
        $columns = $r->columns;
        $order = $r->order;
        $orderBy = 'id_cid';
        $order_dir = 'ASC';
        if($order[0]){
            $column = $order[0]['column']; 
            $orderBy = $columns[$column]['data'];
            $order_dir = $order['dir'];
        }
        $data = CID::orderBy($orderBy, $order_dir);
        
        $result = getDataCustom($data, $r, 'id_cid', 'cid_name')->original;
        return response()->json($result);
    }
}
