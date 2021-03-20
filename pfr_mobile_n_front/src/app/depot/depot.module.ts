import { DynamicModule } from './../components/dynamic.module';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { DepotPage } from './depot.page';
import { PanelComponentModule } from '../panel/panel.module';

import { DepotPageRoutingModule } from './depot-routing.module';
import { SuperTabsModule } from '@ionic-super-tabs/angular';


@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    PanelComponentModule,
    SuperTabsModule,
    DynamicModule,
    DepotPageRoutingModule
  ],
  declarations: [DepotPage]
})
export class DepotPageModule {}
