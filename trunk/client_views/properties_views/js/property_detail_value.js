ng_map_profile.controller("facilities", function($scope) {
    // <editor-fold desc="property facility 1"  defaultstate="collapsed">
            $scope.property_facility_1 = 
            {
                "BBQ" : "Barbeque Area",
                "PARKING" : "Parking",
                "JOGGING" : "Jogging Track",
                "PLAYGROUND":"Playground",
                "TENNIS":"Tennis court",
                "SQUASH":"Squash court"
            };
       // </editor-fold>
    // <editor-fold desc="property facility 2"  defaultstate="collapsed">
            $scope.property_facility_2 = 
            {
                "BusinessCenter" : "Bussiness Center",
                "GYM":"Gymnasium",
                "MINIMART":"Mini market",
                "SALON":"Salon",
                "SWIMMING":"Swimming Pool",
                "SECURITY":"24 Hours Security"
            };
       // </editor-fold>
    // <editor-fold desc="property facility 1"  defaultstate="collapsed">
            $scope.property_facility_3 = 
            {
                "CLUB":"Club House",
                "JACUZZI":"Jacuzzi",
                "NURSERY":"Nursery",
                "SAUNA":"Sauna",
                "CAFE":"Cafeteria",
                "LIBRARY":"Library"
            };
       // </editor-fold>
        
});


ng_map_profile.controller("listing_prefix", function($scope) {
    // <editor-fold desc="listing_prefix"  defaultstate="collapsed">
    // Baselne detail information
    var detail_info = [
        [{
            'label': 'Type',
            'id':'type',
            'category':'sell rent room'

        },
        {
            'label': 'Tenure',
            'id':'tenure',
            'category':'sell'

        },
        {
            'label': 'Property Category',
            'id':'property_category',
            'category':'sell rent room'
        },
        {
            'label': 'Property Type',
            'id':'property_type',
            'category':'sell rent room'
        },
        {
            'label': 'Built Up',
            'id':'built_up',
            'category':'sell rent'

        },
        {
            'label': 'Land Area',
            'id':'land_area',
            'category':'sell rent'


        },
        {
            'label': 'Size Measure Code',
            'id':'measurement_type',
            'category':'sell rent'

        }],
        [{
            'label': 'Monthly Maintenance',
            'id':'monthly',
            'category':'sell'

        },
        {
            'label': 'Reserve Type',
            'id':'reserve_type',
            'category':'sell'

        },
        {
            'label': 'Land Title Type',
            'id':'land_title_type',
            'category':'sell'

        },
        {
            'label': 'Furnishing',
            'id':'furnishing',
            'category':'sell rent room'

        },
        {
            'label': 'Occupied',
            'id':'occupied',
            'value': 'No',
            'category':'sell rent room'

        },
        {
            'label': 'Reference',
            'id':'reference',
            'category':'sell rent room'

        },
        {
            'label': 'Auction',
            'id':'auction',
            'category':'sell'

        }]
    ];

    var list_of_unit_conversion = [
        {
                'value':'sqft',
                'display':'Square feet (sqft)'
        },
        {
                'value':'m2',
                'display':'Square metres (m2)'
        }
    ];

    // Create baseline information
    $scope.property_information = {}; 
    $scope.property_information["details"] = detail_info;
    $scope.property_information["list_of_unit_conversion"] = list_of_unit_conversion;

    // </editor-fold>
        
});