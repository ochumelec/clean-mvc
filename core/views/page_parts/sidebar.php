<?php if ($this->check_login):
    if ($this->show_sidebar):
        if (count($this->sidebar_menu)):
            ?>
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <?php foreach ($this->sidebar_menu as $menu): ?>
                        <li class="<?php echo $active = ($this->action == $menu['link']) ? 'active' : '' ;?>">
                            <a href="<?php echo '/adm/' . $this->controller . '/' . $menu['link']; ?>">
                                <?php echo $menu['name']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        endif;
    endif;
endif; ?>