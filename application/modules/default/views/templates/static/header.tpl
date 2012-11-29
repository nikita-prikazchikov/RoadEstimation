<div class="navbar navbar-static-top">
    <div class="navbar-inner">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="nav-collapse">
            <ul id="headerMainNav" class="nav">
                <li>
                    <a href="{$this->url(['controller' => 'road', 'action' => 'index'])}">
                        <i class="icon-th-large"></i> Дороги
                    </a>
                </li>
                <li>
                    <a href="{$this->url(['controller' => 'calc', 'action' => 'index'])}">
                        <i class="icon-th-large"></i> Расчеты
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">header.init();</script>

