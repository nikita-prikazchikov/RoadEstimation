<div class="well">
    <dl>
        <dt>Математическое ожидание</dt>
        <dd>{$data->getExpectationValue()|default:"-"}</dd>
        <dt>Дисперсия</dt>
        <dd>{$data->getDispersion()|default:"-"}</dd>
    </dl>
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