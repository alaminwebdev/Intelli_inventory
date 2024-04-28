<?php

namespace App;

class RoleEnum
{
    const SUPER_ADMIN = 2;
    const R_MAKER = 3; // Requisition Maker
    const R_RECOMMENDER = 4; // Requisition Recommender
    const R_APPROVER = 5; // Requisition Approver
    const R_DISTRIBUTOR = 6; //Issuer/Distributor
    const R_VERIFIER = 7; //Issuer/Distributor
    const VIEWER = 8; //Viewer
}