require(
    [
        'Magento_Ui/js/lib/validation/validator',
        'jquery',
        'mage/translate'
    ], function (validator, $) {
        validator.addRule(
            'validate-end-date',
            function (value) {
                var inputStartDate = $("input[name='start_date']");
                if (inputStartDate.val() != '') {
                    inputStartDate.parent()
                        .parent()
                        .removeAttr('class')
                        .attr('class', 'admin__field _required');

                    inputStartDate.siblings('.admin__field-error').remove();
                }

                var arrEndDate = value.split('/'),
                    arrStartDate = $("input[name='start_date']").val().split('/'),
                    flag = true,
                    endYear = parseInt(arrEndDate[2]),
                    startYear = parseInt(arrStartDate[2]);

                typeof endYear;
                typeof startYear;

                if (endYear < startYear) {
                    flag = false;
                } else if (arrEndDate[2] = parseInt(arrStartDate[2])) {
                    if (arrEndDate[0] > parseInt(arrStartDate[0])) {
                        flag = true;
                    } else if (arrEndDate[0] = parseInt(arrStartDate[0])) {
                        flag = (arrEndDate[1] < parseInt(arrStartDate[1])) ? false : true;
                    } else {
                        flag = false;
                    }
                } else {
                    flag = true;
                }

                return flag;
            },
            $.mage.__('End date must be greater than start date.')
        );

        validator.addRule(
            'validate-start-date',
            function (value) {
                var inputStartDate = $("input[name='end_date']");
                if (inputStartDate.val() != '') {
                    inputStartDate.parent()
                        .parent()
                        .removeAttr('class')
                        .attr('class', 'admin__field _required');

                    inputStartDate.siblings('.admin__field-error').remove();
                }


                var flag = true,
                    arrStartDate = value.split('/'),
                    arrEndDate = inputStartDate.val().split('/'),
                    endMonth = parseInt(arrEndDate[0]),
                    startMonth = arrStartDate[0];
                if ($("input[name='end_date']").val() == '') {
                    flag = true;
                } else {
                    if (parseInt(arrEndDate[2]) > arrStartDate[2]) {
                        flag = true;
                    } else if (arrStartDate[2] == parseInt(arrEndDate[2])) {
                        if (parseInt(arrEndDate[0]) > arrStartDate[0]) {
                            flag = true;
                        } else if (endMonth == startMonth) {
                            flag = (parseInt(arrEndDate[1]) < arrStartDate[1]) ? false : true;
                        } else {
                            flag = false;
                        }
                    } else {
                        flag = false;
                    }
                }
                if (flag == false) {

                }
                return flag;
            },
            $.mage.__('End date must be greater than start date.')
        );

        validator.addRule(
            'validate-end-time',
            function (value) {
                var inputStartTime = $("input[name='start_time']");
                if (inputStartTime.val() != '') {
                    inputStartTime.parent()
                        .parent()
                        .removeAttr('class')
                        .attr('class', 'admin__field _required');

                    inputStartTime.siblings('.admin__field-error').remove();
                }

                var endTime = value.split(' '),
                    arrEndTime = endTime[0].split(':'),
                    startTime = inputStartTime.val().split(' '),
                    arrStartTime = startTime[0].split(':'),
                    flag = true;

                if (startTime[1].toUpperCase() == 'PM' && endTime[1].toUpperCase() == 'AM') {
                    flag = false;
                } else if (startTime[1].toUpperCase() == endTime[1].toUpperCase()) {
                    flag = (parseInt(arrEndTime[0]) * 60 + parseInt(arrEndTime[1]) > parseInt(arrStartTime[0]) * 60 + parseInt(arrStartTime[1])) ? true : false;
                } else {
                    flag = true;
                }


                return flag;
            },
            $.mage.__('End time must be greater than start time.')
        );

        validator.addRule(
            'validate-start-time',
            function (value) {
                var inputEndTime = $("input[name='end_time']");
                if (inputEndTime.val() != '') {
                    inputEndTime.parent()
                        .parent()
                        .removeAttr('class')
                        .attr('class', 'admin__field _required');

                    inputEndTime.siblings('.admin__field-error').remove();
                }

                var flag = true,
                    startTime = value.split(' '),
                    arrStartTime = startTime[0].split(':'),
                    endTime = inputEndTime.val().split(' '),
                    arrEndTime = endTime[0].split(':');

                if (startTime[1].toUpperCase() == 'PM' && endTime[1].toUpperCase() == 'AM') {
                    flag = false;
                } else if (startTime[1].toUpperCase() == endTime[1].toUpperCase()) {
                    flag = (parseInt(arrEndTime[0]) * 60 + parseInt(arrEndTime[1]) > parseInt(arrStartTime[0]) * 60 + parseInt(arrStartTime[1])) ? true : false;
                } else {
                    flag = true;
                }


                return flag;
            },
            $.mage.__('End time must be greater than start time.')
        );

        validator.addRule(
            'age-teacher',
            function (value) {
                flag = false;
                if(value >= 10 && value<=80){
                    flag = true;
                }
                return flag;
            },
            $.mage.__('The teacher\'s age must be greater than 20 and less than 80.')
        );
    });