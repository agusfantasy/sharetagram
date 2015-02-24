<?php foreach ($tags->data as $row): ?>
    <ul>
        <li>
            <a href="<?php echo "/tag/$row->name" ?>">#<?php echo $row->name ?></a>
            <span> <?php echo $row->media_count ?> </span>
        </li>
    </ul>
<?php endforeach ?>