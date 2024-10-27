<aside>
    <!-- kontrolieren views ob null ist oder nicht -->
    <?php if($top_posts != null): ?>
    <!-- CLASS: fuer WIEDERHOLEN -->
    <div class="aside-box">
        <h2>Top Post</h2>
        <ul>
            <?php foreach($top_posts as $item): ?>
                <li><a href="single.php?post=<?= $item['id'] ?>"><?= $item['title'] ?> <small><?= ($item['view']) ?></small></a></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>
    <?php if($last_posts != null): ?>
        <div class="aside-box">
            <h2>Last Post</h2>
            <ul>
                <?php foreach($last_posts as $item): ?>
                    <li><a href="single.php?post=<?= $item['id'] ?>"><?= $item['title'] ?> <small>(<?= date('Y M d', strtotime($item['date'])) ?>)</small></a></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
</aside>