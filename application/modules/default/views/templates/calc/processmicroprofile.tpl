<div class="well">
    <dl>
        <dt>Математическое ожидание</dt>
        <dd>{$data->getExpectationValue()|default:"-"}</dd>
        <dt>Дисперсия</dt>
        <dd>{$data->getDispersion()|default:"-"}</dd>
    </dl>
</div>
<h4>Корелляционная функция</h4>
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
