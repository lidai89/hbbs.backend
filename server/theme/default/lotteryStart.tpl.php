<div>

   <h1>圣诞-春节 节日抽奖</h1>

   <div class="headerbox">
      抽奖正式开始，不能撤销 :) 所以抽奖前请详细阅读<a href="/lottery/rules">规则</a><br />每次抽奖得到的数值为0到100内的一个随机数字<br />抽奖次数越多，平均值将会越接近中间数字50<br />
      每两次抽奖间隔时间为至少1分钟<br />
      <a  href="/node/10445">抽奖活动讨论贴</a>
   </div>

   <div style="margin: 10px 0;"><a class="bigbutton" href="/lottery/start/run">点击抽奖</a></div>


   <?php echo '综合分数 : ' . sprintf('%8.3f', $average) . '<br />奖券平均值 : ' . sprintf('%8.3f', $aPoints[sizeof($aPoints)]) . ' (抽奖次数 : ' . sizeof($results[sizeof($results)]) . ' 次)<br />'; ?>

   <br />抽奖记录 :
   <table>
      <tbody>
         <?php foreach ($results as $round => $roundResults): ?>
            <tr>
               <th>时间</th>
               <th>分数 <?php echo '(' . sprintf('%4.1f', $aPoints[$round]) . ')'; ?></th>
               <th>标签</th>
            </tr>
            <?php foreach ($roundResults as $r): ?>
               <tr>
                  <td><?php echo date('m/d/Y H:i:s', $r['time']); ?> </td>
                  <td><?php echo $r['points']; ?> </td>
                  <td><?php echo $r['code']; ?> </td>
               </tr>
            <?php endforeach; ?>
         <?php endforeach; ?>
      </tbody>
   </table>

</div>