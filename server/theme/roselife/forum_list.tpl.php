<?= $breadcrumb ?>
<?php foreach ($groups as $group_id => $tags): ?>
  <table>
    <thead>
      <tr>
        <th><?= $tags[$group_id]['description'] ?></th>
        <th>最新话题</th>
        <th>最新回复</th>
      </tr>
    </thead>
    <tbody class='even_odd_parent'>
      <?php foreach ($tags[$group_id]['children'] as $board_id): ?>
        <tr>
          <td><a href="/forum/<?= $board_id ?>"><?= $tags[$board_id]['name'] ?></a></td>
          <td><?php if ($nodeInfo[$board_id]['node']): ?><a href="/node/<?= $nodeInfo[$board_id]['node']['nid'] ?>"><?= $nodeInfo[$board_id]['node']['title'] ?></a><br><?= $nodeInfo[$board_id]['node']['username'] ?> <span class='time'><?= $nodeInfo[$board_id]['node']['create_time'] ?></span><?php endif ?></td>
          <td><?php if ($nodeInfo[$board_id]['comment']): ?><a href="/node/<?= $nodeInfo[$board_id]['comment']['nid'] ?>?p=l#comment<?= $nodeInfo[$board_id]['comment']['cid'] ?>"><?= $nodeInfo[$board_id]['comment']['title'] ?></a><br><?= $nodeInfo[$board_id]['comment']['username'] ?> <span class='time'><?= $nodeInfo[$board_id]['comment']['create_time'] ?></span><?php endif ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
<?php endforeach ?>

<div style="margin-top:15px; clear: both;">
  <div style="padding:0.4em 0.7em;">友情链接</div>
  <div style="padding:0.4em 0.7em; background:#EEEEEE none repeat scroll 0 0;">
    <a style="padding: 4px;" target="_blank" href="http://www.dallasbbs.com">缤纷达拉斯</a>
    <a style="padding: 4px;" target="_blank" href="http://www.austinbbs.com">缤纷奥斯汀</a>
  </div>
</div>
