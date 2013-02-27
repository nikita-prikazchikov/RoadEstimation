<table class="table table-bordered table-striped table-condensed">
    <thead>
    <tr class="table-centered">
        <th rowspan="3">X</th>
        <th rowspan="3">Y</th>
        <th rowspan="3">Средняя</th>
        <th colspan="{count( $data->getSupportList() ) * 2}">Количество опор</th>
    </tr>
    <tr>
    {foreach from=$data->getSupportList() item=key}
        <th colspan="2">{$key}</th>
    {/foreach}
    </tr>
    <tr>
    {foreach from=$data->getSupportList() item=key}
        <th>Y</th>
        <th></th>
    {/foreach}
    </tr>
    </thead>
    <tbody>
    {assign var=average value=$data->getAverageRoad()}
    {foreach from=$data->getSourceRoad()->getCoordinates() item=coordinate}
    <tr>
        <td>{$coordinate->getX()}</td>
        <td>{$coordinate->getY()}</td>
        <td>{$average->getCoordinate($coordinate->getX())}</td>
        {foreach from=$data->getSupportList() item=key}
            <td>{($data->getUnitModelListBySupportCount( $key )->getCoordinate( $coordinate->getX() ))|default:"-"}</td>
            {*<td>{(abs( $data->getUnitModelListBySupportCount( $key )->getCoordinate( $coordinate->getX() ) - $average->getCoordinate($coordinate->getX()) ) * 100 / $average->getCoordinate($coordinate->getX()))|string_format:"%.2f"}%</td>*}
            {*<td>{(abs( $data->getUnitModelListBySupportCount( $key )->getCoordinate( $coordinate->getX() ) - $coordinate->getY() ) )|string_format:"%.2f"}</td>*}
            <td>{( $data->getUnitModelListBySupportCount( $key )->getCoordinate( $coordinate->getX() ) - $coordinate->getY() )|string_format:"%.4f"}</td>
            {*<td>{($average->getCoordinate($coordinate->getX()) - $data->getUnitModelListBySupportCount( $key )->getCoordinate( $coordinate->getX() ))|string_format:"%.4f"}</td>*}
        {/foreach}
    </tr>
    {/foreach}
    </tbody>
</table>
