<?php
 namespace App\Helpers;

use App\Models\ApprovedApplicant;
use App\Models\TrainingPlacement;

class Helper
{

    public static function IDGenerator($model, $trow, $length = 6, $prefix ,$postfix){
        $ap = TrainingPlacement::where('training_session_id',1);

        $count=$ap->count();
        dd($count);
        $data = $model::orderBy('id','desc')->first();
        // dd($data);



        if(!$data){
            $og_length = $length;
            $last_number = '';
        }else{

            $code = substr($data->$trow, (3+strlen($postfix)+strlen($prefix)+1),-2);
            $actial_last_number = (int)((int)$code/1)*1;
            $increment_last_number = ((int)$actial_last_number)+1;
            $last_number_length = strlen($increment_last_number);
            $og_length = $length - $last_number_length;
            $last_number = $increment_last_number;

        }
        $zeros = "";
        for($i=0;$i<$og_length;$i++){
            $zeros.="0";
        }
        return 'MOP-'.$prefix.'-'.$zeros.$last_number.'/'.$postfix;
    }
}
?>
