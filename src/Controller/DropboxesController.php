<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

class DropboxesController extends AppController
{
    public function index($parent_id = 0)
    {
        $this->set('datatableUrl', Router::url([
            'action' => 'ajaxData'
        ]));
        $this->loadModel('Folders');
        $this->paginate = [
            'contain' => ['Users'],
            'conditions' => ['parent_id' => $parent_id],
            'limit' => 10
        ];
        $folders =$this->paginate($this->Folders);
        $parent_id && $crumbs = $this->Folders->find('path',['for' => $parent_id]);
        $this->set(compact('folders','parent_id','crumbs'));
    }

    function ajaxData() {
        $aColumns = array( 'Folders.name', 'Folders.phone', 'booking_time', 'departure_time', 'number_of_people', 'amount','Folders.id' );
        $iDisplayStart = $this->request->query('iDisplayStart');
        $iDisplayLength = $this->request->query('iDisplayLength');
        $sSearch = $this->request->query('sSearch');
        $sEcho = $this->request->query('sEcho');

        //Paging
        $startPage = 1;
        if($iDisplayStart == 0){
            $startPage = 1;
        }else{
            $startPage +=  $iDisplayStart / $iDisplayLength;
        }

        //Ordering
        $sOrder;
        if ( isset( $_GET['iSortCol_0'] ) )
        {
            $sOrder = "";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
            {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                {
                    $sOrder[] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
                        ($_GET['sSortDir_'.$i]==='asc' ? 'ASC' : 'DESC');
                }
            }
        }

        $sWhere = null;

        if ( isset($_GET['bSearchable_0']) && $_GET['bSearchable_0'] == "true" && $_GET['sSearch_0'] != '' )
        {
            $sWhere[$aColumns[0].' LIKE'] = "%".$_GET['sSearch_0']."%";
        }
        if ( isset($_GET['bSearchable_1']) && $_GET['bSearchable_1'] == "true" && $_GET['sSearch_1'] != '' )
        {
            $sWhere[$aColumns[1].' LIKE'] = "%".$_GET['sSearch_1']."%";
        }
        if ( isset($_GET['bSearchable_6']) && $_GET['bSearchable_6'] == "true" && $_GET['sSearch_6'] != '' )
        {
            $sWhere[$aColumns[6]] = $_GET['sSearch_6'];
        }
        if ( isset($_GET['bSearchable_3']) && $_GET['bSearchable_3'] == "true" && $_GET['sSearch_3'] != '' )
        {
            $sWhere['booking_time >='] = $_GET['sSearch_3'];
        }
        if ( isset($_GET['bSearchable_4']) && $_GET['bSearchable_4'] == "true" && $_GET['sSearch_4'] != '' )
        {
            $sWhere['booking_time <='] = $_GET['sSearch_4'];
        }


        $conditions = array('AND' => $sWhere);

        $bookings = $this->Bookings
            ->find('all',[
                    'order' => $sOrder,
                    'conditions' => $sWhere!=null?$conditions:[]
                ])
            ->contain('Folders')
            ->limit($iDisplayLength)->page($startPage);

        foreach ($bookings as $row){
            $row['booking_time'] = date_format($row['booking_time'], 'Y-m-d H:i');
            $row['departure_time'] = date_format($row['departure_time'], 'Y-m-d H:i');
        }
        $result['aaData'] = $bookings;
        $result['sEcho'] = intval($sEcho);
        $result['iTotalRecords'] = $bookings->count();
        $result['iTotalDisplayRecords'] = $bookings->count();
        $this->response->body(json_encode($result));
        return $this->response;
    }

    private function getDirSize($dir)
     { 
      $handle = opendir($dir);
      while (false!==($FolderOrFile = readdir($handle)))
      { 
       if($FolderOrFile != "." && $FolderOrFile != "..") 
       { 
        if(is_dir("$dir/$FolderOrFile"))
        { 
         $sizeResult += getDirSize("$dir/$FolderOrFile"); 
        }
        else
        { 
         $sizeResult += filesize("$dir/$FolderOrFile"); 
        }
       } 
      }
      closedir($handle);
      return $sizeResult;
     }
     // 单位自动转换函数
     private function getRealSize($size)
     { 
      $kb = 1024;   // Kilobyte
      $mb = 1024 * $kb; // Megabyte
      $gb = 1024 * $mb; // Gigabyte
      $tb = 1024 * $gb; // Terabyte
      if($size < $kb)
      { 
       return $size." B";
      }
      else if($size < $mb)
      { 
       return round($size/$kb,2)." KB";
      }
      else if($size < $gb)
      { 
       return round($size/$mb,2)." MB";
      }
      else if($size < $tb)
      { 
       return round($size/$gb,2)." GB";
      }
      else
      { 
       return round($size/$tb,2)." TB";
      }
     }
     // echo getRealSize(getDirSize('需要获取大小的目录'));
}