<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <?php 
                $session = Yii::$app->session;
                $user = $session->get('user');

                // $query = 'SELECT * FROM menu WHERE id IN (SELECT id_menu FROM `role_access` WHERE id_bidang="'.$user->bidang_mitra.'") AND status=1 ORDER BY `order` ASC';
                // $result = Yii::$app->db->createCommand($query)->queryAll();
                // echo "<pre>"; print_r($result);echo "</pre>";die();
                // $session->set('menu',$result);

                $menu = $session->get('menu');
                $all_menu = [];
                $all_menu[] = ['label' => 'Menu', 'options' => ['class' => 'header']];
                if ($menu!='' || !empty($menu)) {
                    foreach ($menu as $key => $value) {
                        if ($value['route']=='') {
                            $all_menu[] = ['label' => $value['name'], 'icon' => $value['icon'], 'url' => '#', 'xid'=>'parent'.$value['id']];
                        }else if ($value['route']!='' && $value['parent'] == ''){
                            $all_menu[] = ['label' => $value['name'], 'icon' => 'circle-o', 'url' => [$value['route']]];
                        }
                    }
                    foreach ($menu as $key => $value) {
                        if ($value['route']!='' && $value['parent'] != '') {
                            foreach ($all_menu as $key1 => $value1) {
                                if ($value1['xid'] == 'parent'.$value['parent']) {
                                    $all_menu[$key1]['items'][] = ['label' => $value['name'],'icon'=>'asterisk', 'url' => [$value['route']]];
                                }
                            }
                        }
                    }
                }
                ksort($all_menu);
                $fixmenu = [];
                foreach ($all_menu as $key => $value) {
                    $fixmenu[] = $value;
                }
                // echo "<pre>"; print_r($fixmenu);echo "</pre>";
                // die();
                ?>
                <p><?= $user['username'] ?></p>
            </div>
        </div>
        <?php echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => $fixmenu,
                // [
                    // ['label' => 'Menu', 'options' => ['class' => 'header']],
                    // ['label' => 'Dashboard', 'icon' => 'circle-o', 'url' => ['site/index']],
                    // ['label' => 'Pendaftaran', 'icon' => 'circle-o', 'url' => ['/pendaftaran']],
                    // ['label' => 'Peserta', 'icon' => 'circle-o', 'url' => ['/peserta']],
                    // ['label' => 'Notifikasi', 'icon' => 'circle-o', 'url' => ['/notifikasi']],
                    // ['label' => 'Persetujuan', 'icon' => 'circle-o', 'url' => ['/persetujuan']],
                    // ['label' => 'User', 'icon' => 'circle-o', 'url' => ['/user']],
                    // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    // [
                    //     'label' => 'Some tools',
                    //     'icon' => 'share',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                    //         ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                    //         [
                    //             'label' => 'Level One',
                    //             'icon' => 'circle-o',
                    //             'url' => '#',
                    //             'items' => [
                    //                 ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    //                 [
                    //                     'label' => 'Level Two',
                    //                     'icon' => 'circle-o',
                    //                     'url' => '#',
                    //                     'items' => [
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                     ],
                    //                 ],
                    //             ],
                    //         ],
                    //     ],
                    // ],
                // ],
            ]
        ) ?>

    </section>

</aside>
