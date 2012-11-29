<div class="modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Добавить/редактировать дорогу</h3>
    </div>
    <div class="modal-body">
        <div class="form row-fluid">
            <input class="hidden" id="edit-road-id" value="{$road->getId()}">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Имя дороги</label>

                    <div class="controls">
                        <input class="text span12" id="edit-road-name" value="{$road->getName()|escape:"html"}"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Шаг</label>

                    <div class="controls">
                        <input class="text span12" id="edit-road-step" value="{$road->getStep()}"/>
                    </div>
                </div>
            {if $road->getId() !== null}
                <div class="control-group">
                    <label class="control-label">Файл данных</label>

                    <div class="controls">
                        <input type="file" class="span12" id="edit-road-data" value=""/>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="btn btn-primary" id="edit-road-upload"><i class="icon-white icon-upload"></i>
                            Загрузить файл данных
                        </div>
                    </div>
                </div>
            {/if}
            </fieldset>
        </div>
        <div id="modal_alert" class="alert alert-error fade in" style="display: none"></div>
        <div id="modal_alert_success" class="alert alert-success fade in" style="display: none"></div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary btn-road-submit"><i class="icon-ok icon-white"></i> Сохранить</a>
        <a href="#" class="btn" data-dismiss="modal"><i class="icon-ban-circle"></i> Отмена</a>
    </div>
</div>
<script type="text/javascript">pages.road.dialog.init();</script>
