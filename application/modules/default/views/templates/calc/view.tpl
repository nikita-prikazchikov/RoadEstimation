<div class="container-calculation">
    <div class="well">
        <div class="form form-horizontal">
            <div class="control-group">

                <label class="control-label">Масса (кг)</label>

                <div class="controls">
                    <input class="span3" type="text" name="filter-weight" class="span1" value="500"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Длина (м)</label>

                <div class="controls">
                    <input class="span3" type="text" name="filter-length" class="span1" value="14"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Количество опор</label>

                <div class="controls">
                    <input class="span3" type="text" name="filter-support" class="span1" value="2,10"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Дорога</label>

                <div class="controls">
                    <select class="span3" name="filter-road">
                        {html_options options=$roadList->getListView()}
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Модель</label>

                <div class="controls">
                    <select class="span3" name="filter-model">
                    {html_options options=$modelList}
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <div class="btn btn-primary btn-road-calculate"><i class="icon-white icon-ok"></i> Расчитать</div>
                <div class="btn btn-primary btn-road-process"><i class="icon-white icon-ok"></i> Обработать микропрофиль</div>
            </div>
        </div>
    </div>
    <div class="row-fluid result-container">
    </div>
</div>
<script type="text/javascript">pages.calc.view.init();</script>
