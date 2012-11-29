<table class="table table-bordered table-striped table-condensed">
    <thead>
    <tr class="">
        <th class="">Имя</th>
        <th class="">Шаг</th>
        <th class="">Действия</th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$roadList->getList() item=road}
    <tr>
        <td>{$road->getName()}</td>
        <td>{$road->getStep()}</td>
        <td>
            <div class="btn btn-mini btn-road-edit" data-id="{$road->getId()}">
                <i class="icon-pencil"></i></div>
        </td>
    </tr>
        {foreachelse}
    <div class="alert alert-info">Нет дорог для отображения</div>
    {/foreach}
    </tbody>
</table>
<script type="text/javascript">pages.road.list.init();</script>