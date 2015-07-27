<form id="manager-flight-response-form-empty" class="form-horizontal" action="/tour/create-tour-manager" method="post">
    <input type="hidden" name="_csrf" value="VE5Hc0pmOVcjBBAxEFFTAREsICIkN3guMwwqLDkSTmQXLyI8B1UMIw==">

    <div class="form-group field-createtourform-destination required">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-destination"><?=Yii::t('app', 'Destination');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><select id="createtourform-destination" class="form-control" name="CreateTourForm[destination]">
                <option value=""><?=Yii::t('app', 'Choose destination');?></option>
            </select></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>
    <div class="form-group field-createtourform-resort required">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-resort"><?=Yii::t('app', 'Resort/City');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><select id="createtourform-resort" class="form-control" name="CreateTourForm[resort]">
                <option value=""><?=Yii::t('app', 'Choose destination');?></option>
            </select></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>
    <div class="form-group field-userflightform-way_ticket">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="userflightform-way_ticket"><?=Yii::t('app', 'Way ticket');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><input type="hidden" name="UserFlightForm[way_ticket]" value=""><div id="userflightform-way_ticket"><div class="checkbox-one type"><label><span class="line-name">В одну сторону</span><input type="radio" name="UserFlightForm[way_ticket]" value="1" checked=""></label></div>
                <div class="checkbox-one type"><label><span class="type-name">В обе стороны</span><input type="radio" name="UserFlightForm[way_ticket]" value="2"></label></div></div></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>
    <div class="form-group field-userflightform-depart_city required">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="userflightform-depart_city"><?=Yii::t('app', 'Depart city to');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><select id="userflightform-depart_city" class="form-control" name="UserFlightForm[depart_city]">
                <option value="832">Москва</option>
            </select></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>

    <div class="form-group">
        <div class="col-xs-11 col-xs-offset-1">
            <button type="submit" id="create-flight-response" class="btn btn-success col-xs-12 inactive" name="create-tour-button"><?=Yii::t('app', 'Request answer');?></button>    </div>
    </div>

</form>