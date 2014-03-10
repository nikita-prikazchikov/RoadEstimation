<table class="table table-bordered table-striped table-condensed">
    <tr>
        <th>Длина сглаживания</th>
        <th>Альфа</th>
        <th>Бетта</th>
        <th>Дисперсия</th>
    </tr>
    {foreach item=line from=$data}
        <tr>
            <td>{$line->getLength()}</td>
            <td>{$line->getAlpha()}</td>
            <td>{$line->getBeta()}</td>
            <td>{$line->getDispersion()}</td>
        </tr>
    {/foreach}
</table>