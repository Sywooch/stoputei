<form id="manager-tour-response-form-empty" class="form-horizontal" action="/tour/create-tour-manager" method="post">
    <input type="hidden" name="_csrf" value="VE5Hc0pmOVcjBBAxEFFTAREsICIkN3guMwwqLDkSTmQXLyI8B1UMIw==">

    <div class="form-group field-createtourform-destination required">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-destination"><?=Yii::t('app', 'Destination');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><select id="createtourform-destination" class="form-control" name="CreateTourForm[destination]">
                <option value=""><?=Yii::t('app', 'Choose destination');?></option>
            </select></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>
    <div class="form-group field-createtourform-resort required">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-resort"><?=Yii::t('app', 'Resort');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><select id="createtourform-resort" class="form-control" name="CreateTourForm[resort]">
                <option value=""><?=Yii::t('app', 'Choose destination');?></option>
            </select></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>
    <div class="form-group field-createtourform-hotel">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-hotel">Отель</label><div class="col-xs-11 col-xs-offset-1 create-tour-response"><input type="text" id="createtourform-hotel" class="form-control" name="CreateTourForm[hotel]"><i class="glyphicon glyphicon-remove-circle remove-hotel-name"></i></div>
    </div>
    <div class="form-group field-createtourform-hotel_id">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-hotel_id"></label>
        <div class="col-xs-11 col-xs-offset-1 "><input type="hidden" name="CreateTourForm[hotel_id]" value=""><select id="createtourform-hotel_id" class="form-control" name="CreateTourForm[hotel_id][]" multiple="" size="4">

            </select></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>
    <a class="ajax-hotel-autocomplete" href="/tour/ajax-hotels-autocomplete"></a>

    <div class="form-group field-createtourform-stars required">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-stars"><?=Yii::t('app', 'Category');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><input type="hidden" name="CreateTourForm[stars]" value=""><div id="createtourform-stars"><div class="checkbox"><label><span class="star"><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i></span><input type="checkbox" name="CreateTourForm[stars][]" value="404" checked=""></label></div>
                <div class="checkbox"><label><span class="star"><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i></span><input type="checkbox" name="CreateTourForm[stars][]" value="403"></label></div>
                <div class="checkbox"><label><span class="star"><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i></span><input type="checkbox" name="CreateTourForm[stars][]" value="402" checked=""></label></div>
                <div class="checkbox"><label><span class="star"><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i></span><input type="checkbox" name="CreateTourForm[stars][]" value="401"></label></div>
                <div class="checkbox"><label><span class="star"><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i><i class="glyphicon glyphicon-star-empty"></i></span><input type="checkbox" name="CreateTourForm[stars][]" value="400"></label></div></div></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div><div class="form-group field-createtourform-nutrition">
        <label class="col-xs-11 col-xs-offset-1 control-label label-get-tour" for="createtourform-nutrition"><?=Yii::t('app', 'Nutrition');?></label>
        <div class="col-xs-11 col-xs-offset-1 "><input type="hidden" name="CreateTourForm[nutrition]" value=""><div id="createtourform-nutrition"><div class="checkbox-one col-xs-6"><label><span class="type-name" title="" data-toggle="tooltip" data-placement="right" data-original-title="Без питания">RO</span><input type="checkbox" name="CreateTourForm[nutrition][]" value="0" checked=""></label></div>
                <div class="checkbox-one col-xs-6"><label><span class="line-name" title="" data-toggle="tooltip" data-placement="right" data-original-title="Завтраки">BB</span><input type="checkbox" name="CreateTourForm[nutrition][]" value="1"></label></div>
                <div class="checkbox-one col-xs-6"><label><span class="line-name" title="" data-toggle="tooltip" data-placement="right" data-original-title="Завтраки, ужины">HB</span><input type="checkbox" name="CreateTourForm[nutrition][]" value="2"></label></div>
                <div class="checkbox-one col-xs-6"><label><span class="line-name" title="" data-toggle="tooltip" data-placement="right" data-original-title="Завтраки, ужины, расширеное меню">HB+</span><input type="checkbox" name="CreateTourForm[nutrition][]" value="3"></label></div>
                <div class="checkbox-one col-xs-6"><label><span class="line-name" title="" data-toggle="tooltip" data-placement="right" data-original-title="Завтраки, обеды,ужины, расширенное меню">FB+</span><input type="checkbox" name="CreateTourForm[nutrition][]" value="4"></label></div>
                <div class="checkbox-one col-xs-6"><label><span class="line-name" title="" data-toggle="tooltip" data-placement="right" data-original-title="Завтраки, обеды, ужины, напитки">AL</span><input type="checkbox" name="CreateTourForm[nutrition][]" value="5"></label></div>
                <div class="checkbox-one col-xs-6"><label><span class="line-name" title="" data-toggle="tooltip" data-placement="right" data-original-title="Завтраки, обеды, ужины, напитки, расширенное меню">UAL</span><input type="checkbox" name="CreateTourForm[nutrition][]" value="6"></label></div></div></div>
        <div class="col-xs-11 col-xs-offset-1"><div class="help-block"></div></div>
    </div>
    <div class="form-group">
        <div class="col-xs-11 col-xs-offset-1">
            <button type="submit" id="create-tour-response" class="btn btn-success col-xs-12 inactive" name="create-tour-button"><?=Yii::t('app', 'Create a tour');?></button>    </div>
    </div>

</form>