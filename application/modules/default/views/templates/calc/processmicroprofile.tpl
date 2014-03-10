<div class="well">
    <dl>
        <dt>Математическое ожидание</dt>
        <dd>{$data->getExpectationValue()|default:"-"}</dd>
        <dt>Дисперсия</dt>
        <dd>{$data->getDispersion()|default:"-"}</dd>
    </dl>
</div>


<div class="accordion" id="smoothed-road-accordion">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#smoothed-road-accordion" href="#result-accordion-group-road">
                <h4>Сглаженный профиль</h4>
            </a>
        </div>
        <div id="result-accordion-group-road" class="accordion-body collapse">
            <div class="accordion-inner">
                <table class="table table-bordered table-striped table-condensed">
                    {assign var=road value=$data->getSmoothedRoad()}
                    <thead>
                    <tr>
                        <th>X</th>
                        <th>Y</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$road->getCoordinates() key=k item=value}
                        <tr>
                            <td>{$value->getX()}</td>
                            <td>{$value->getY()}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="accordion" id="result-accordion">
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#result-accordion" href="#result-accordion-group-correlation">
                <h4>Корелляционная функция</h4>
            </a>
        </div>
        <div id="result-accordion-group-correlation" class="accordion-body collapse">
            <div class="accordion-inner">
                <table class="table table-bordered table-striped table-condensed">
                    {assign var=correlation value=$data->getCorrelation()}
                    <thead>
                    <tr>
                        <th>K</th>
                        <th>Значение</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$correlation key=k item=value}
                        <tr>
                            <td>{$k}</td>
                            <td>{$value}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<h4>Расчеты</h4>
<div class="well">
    <dl>
        <dt>Альфа</dt>
        <dd>{$data->getAlpha()|default:"-"}</dd>
        <dt>Бета</dt>
        <dd>{$data->getBeta()|default:"-"}</dd>
        <dt>Тау штрих</dt>
        <dd>{$data->getTau()|default:"-"}</dd>
    </dl>
</div>
<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th>Тау</th>
        <th>ro_tau</th>
        <th>ro_tau рассчетное</th>
    </tr>
    {foreach item=line from=$data->getResultTable()}
        <tr>
            <td>{$line["tau"]}</td>
            <td>{$line["ro_tau"]}</td>
            <td>{$line["ro_tau_calc"]}</td>
        </tr>
    {/foreach}
</table>