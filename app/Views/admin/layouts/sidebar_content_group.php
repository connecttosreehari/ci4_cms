<?php if (!empty($content_group) && $content_group->hide_group != 1) :
    if ($related_group_ids) {
        foreach ($related_group_ids as $key => $related_group_id) {
            $related_group_ids[$key] = 'content_group_' . $related_group_id;
        }
    }
?>
    <li class="nav-item <?= in_array($active_menu, $related_group_ids) || $active_menu == 'content_group_' . $content_group->id ? 'menu-open' : '' ?>">
        <a href="<?= !in_array($active_menu, $related_group_ids) ? base_url(route_to('contents', $content_group->id, $site_lang)) : '' ?>" class="nav-link <?= in_array($active_menu, $related_group_ids) || $active_menu == 'content_group_' . $content_group->id ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
                <?= $content_group->title ?>
            </p>
            <?php if (!empty($content_related_groups)) : ?>
                <i class="right fas fa-angle-left"></i>
            <?php endif; ?>
        </a>
        <?php
        if (!empty($content_related_groups)) : ?>
            <?php foreach ($content_related_groups as $content_related_group) :
                if ($content_related_group->hide_group == 1) continue; ?>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url(route_to('contents', $content_related_group->id, $site_lang)) ?>" class="nav-link <?= $active_menu == 'content_group_' . $content_related_group->id ? 'active' : '' ?>">
                            <i class="nav-icon <?= $content_related_group->menu_icon ? $content_related_group->menu_icon : 'fas fa-file-alt' ?>"></i>
                            <p>
                                <?= $content_related_group->title ?>
                            </p>
                        </a>
                    </li>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>
    </li>
<?php endif; ?>