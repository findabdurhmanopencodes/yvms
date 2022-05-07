"use strict";

// Class definition
var KTWizard2 = function () {
    // Base elements
    var _wizardEl;
    var _formEl;
    var _wizard;
    var _validations = [];

    // Private functions
    var initWizard = function () {
        // Initialize form wizard
        _wizard = new KTWizard(_wizardEl, {
            startStep: 4, // initial active step number
            clickableSteps: true // to make steps clickable this set value true and add data-wizard-clickable="true" in HTML for class="wizard" element
        });

        // Validation before going to next page
        _wizard.on('beforeNext', function (wizard) {
            _validations[wizard.getStep() - 1].validate().then(function (status) {
                if (status == 'Valid') {
                    _wizard.goNext();
                    KTUtil.scrollTop();
                } else {
                    swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function () {
                        KTUtil.scrollTop();
                    });
                }
            });

            _wizard.stop(); // Don't go to the next step
        });

        // Change event
        _wizard.on('change', function (wizard) {
            KTUtil.scrollTop();
        });
    }

    var initValidation = function () {
        // Step 1
        _validations.push(FormValidation.formValidation(
            _formEl, {
                fields: {
                    // agree_check: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'You must agree to above code of cunduct'
                    //         }
                    //     }
                    // },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        ));
        // Step 2
        _validations.push(FormValidation.formValidation(
            _formEl, {
                fields: {
                    // photo: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Photo is required'
                    //         },
                    //         file: {
                    //             extension: 'jpeg,jpg,png',
                    //             type: 'image/jpeg,image/png',
                    //             maxSize: 2048000, // 2048 * 1024
                    //             message: 'The selected file is not valid',
                    //         }
                    //     }
                    // },
                    // first_name: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'First name is required'
                    //         },
                    //         stringLength: {
                    //             min: 2,
                    //             message: 'The first name must be greater than 2 characters',
                    //         }
                    //     }
                    // },
                    // father_name: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Grand father name is required'
                    //         },
                    //         stringLength: {
                    //             min: 2,
                    //             message: 'The father name must be greater than 2 characters',
                    //         }
                    //     }
                    // },
                    // grand_father_name: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Grand father name is required'
                    //         },
                    //         stringLength: {
                    //             min: 2,
                    //             message: 'The grand father name must be greater than 2 characters',
                    //         }
                    //     }
                    // },
                    // dob: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Date of Birth is required'
                    //         },
                    //         date: {
                    //             format:'DD/MM/YYYY',
                    //             min:'01/01/2014',
                    //             max:'30/12/2015',
                    //             message: 'Date of Birth is invalid'
                    //         },
                    //     }
                    // },
                    // gender: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Gender is required'
                    //         },
                    //     }
                    // },

                    // phone: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Phone is required'
                    //         },
                    //         regexp: {
                    //             regexp: /^(\+251|0)9[0-9]{8}$/i,
                    //             message: 'Phone is invalid',
                    //         },
                    //     }
                    // },
                    // email: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Email is required'
                    //         },
                    //         emailAddress: {
                    //             message: 'The value is not a valid email address',
                    //         },
                    //     }
                    // },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        ));

        // Step 3
        _validations.push(FormValidation.formValidation(
            _formEl, {
                fields: {
                    // region: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Region is required'
                    //         },
                    //     }
                    // },
                    // zone: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Zone is required'
                    //         },
                    //     }
                    // },
                    // woreda: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Woreda is required'
                    //         },
                    //     }
                    // },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        ));


        // Step 4
        _validations.push(FormValidation.formValidation(
            _formEl, {
                fields: {
                    educational_level: {
                        validators: {
                            notEmpty: {
                                message: 'Educational level is required'
                            },
                        }
                    },
                    field_of_study: {
                        validators: {
                            notEmpty: {
                                message: 'Field of study is required'
                            },
                        }
                    },
                    gpa: {
                        validators: {
                            notEmpty: {
                                message: 'GPA is required'
                            },
                            lessThan:{
                                max: 4.0,
                                inclusive: true,
                                message: 'GPA can\'t be greater than 4.0'
                            },
                            greaterThan:{
                                min: 2.0,
                                inclusive: true,
                                message: 'GPA can\'t be less than 2.0'
                            },
                        }
                    },
                    ministry_document: {
                        validators: {
                            notEmpty: {
                                message: 'Ministry Document is required'
                            },
                            file: {
                                extension: 'pdf,jpeg,jpg,png,rtf',
                                type: 'image/jpeg,image/png,application/pdf,application/rtf',
                                maxSize: 2048000, // 2048 * 1024
                                message: 'Ministry Document file is not valid',
                            }
                        }
                    },
                    bsc_document: {
                        validators: {
                            notEmpty: {
                                message: 'BSC Document is required'
                            },
                            file: {
                                extension: 'pdf,jpeg,jpg,png,rtf',
                                type: 'image/jpeg,image/png,application/pdf,application/rtf',
                                maxSize: 2048000, // 2048 * 1024
                                message: 'BSC Document file is not valid',
                            }
                        }
                    },


                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        ));
    }

    return {
        // public functions
        init: function () {
            _wizardEl = KTUtil.getById('kt_wizard_v2');
            _formEl = KTUtil.getById('kt_form');

            initWizard();
            initValidation();
        }
    };
}();

jQuery(document).ready(function () {
    KTWizard2.init();
});
