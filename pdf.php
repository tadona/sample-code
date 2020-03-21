<?php 
    //require_once ('./pahooCalendar.php');
    //require_once ('./getHoliday.php');

    // 日付取得
    $date = $_POST["text"];
    if(empty($date)){
      // 入力値が空の場合は本日の日付を設定
      $timestamp = date("Y-m-d",strtotime('now'));
    }else{
      // 入力値が空でない場合は画面の値を設定
      $timestamp = date("Y-m-d",strtotime($date)); 
    }

    // 曜日 日本語名を設定
    $week = array( "日", "月", "火", "水", "木", "金", "土" );

    // 祝日を設定
    $syukuzitu = array(
      '01/01',
      '01/13',
      '02/11',
      '02/23',
      '02/24',
      '03/20',
      '04/29',
      '05/03',
      '05/04',
      '05/05',
      '05/06',
      '07/23',
      '07/24',
      '08/10',
      '09/21',
      '09/22',
      '11/03',
      '11/23',
  );

    // 1ケ月の日にちを計算
    for($cnt = 0; $cnt < 31; $cnt++){
      if ($cnt === 0 ) {
        $timestamp = date("m/d", strtotime($timestamp));
      }else{
        $timestamp = date("m/d", strtotime('+1 day ' . $timestamp));
      }
      // 曜日を設定
      $youbi = $week[date("w",strtotime($timestamp))];
      $tmp[$cnt]['timestamp']= $timestamp;
      $tmp[$cnt]['youbi'] = $youbi;
      $tmp[$cnt]['youbiflg'] = 1;
      // 土日祝日は赤色にする
      foreach($syukuzitu as $row){
        if(($timestamp === $row) || ($youbi === "土" || $youbi === "日")){
          $tmp[$cnt]['youbiflg'] = 2;
        }
      }     
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>シフト作成</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
  <div class="mai">
    <form action="pdf.php" method="post" name="form" >
    <table border="2" cellspacing="1" align="center" >
      <tr color="#CCFFFF">
        <th width="45"></th>
        <th width="25"></th>
        <th colspan="3"　width="100">開始</th>
        <th colspan="3"　width="100">終了</th>
        <th width="100"></th>
        <th width="100">食休</th>
        <th width="100">T</th>
        <th width="100">5-7</th>        
        <th width="100">7-9</th>
        <th width="100">土日祝</th>
      </tr>
      <?php foreach ($tmp as $cnt => $date){ ?>
      <tr style="background-color: <?php if($date['youbiflg']===1){ }else{ echo "#FFCCCC;"; }  ?> ">
        <td style="text-align:right; font-size:10px;">
          <?=$date['timestamp'] ?>
        </td>
        <td style="text-align:right; font-size:10px; color: <?php if($date['youbiflg']===1){ echo "black;"; }else{ echo "red;"; }  ?> ">
          <?=$date['youbi'] ?>
        </td>
        <td style="text-align:center; font-size:1px;">
          <textarea  style="width:40px; height:1px;" maxlength="5"></textarea>
        <td style="text-align:center; font-size:1px;">
          :
        </td>
        <td style="text-align:center; font-size:1px;">
          <textarea  style="width:40px; height:1px;" maxlength="5"></textarea>
        </td>
        <td style="text-align:center; font-size:1px;">
          <textarea  style="width:40px; height:1px;" maxlength="5"></textarea>
        <td style="text-align:center; font-size:1px;">
          :
        </td>
        <td style="text-align:center; font-size:1px;">
          <textarea  style="width:40px; height:1px;" maxlength="5"></textarea>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
      </tr>
      <?php } ?> <!--12-->
    </table>
    </form>
  </div>
  </body>
</html>


