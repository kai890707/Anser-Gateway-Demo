<?php

namespace Config;

use SDPMlab\Anser\Service\ServiceList;

ServiceList::addLocalService("product_service","10.1.1.3",8081,false);
ServiceList::addLocalService("order_service","10.1.1.4",8082,false);
ServiceList::addLocalService("payment_service","10.1.1.5",8083,false);
