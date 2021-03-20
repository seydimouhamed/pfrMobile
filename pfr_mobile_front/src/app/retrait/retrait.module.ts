import { SuperTabsModule } from '@ionic-super-tabs/angular';
import { DynamicModule } from './../components/dynamic.module';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RetraitPage } from './retrait.page';
import { PanelComponentModule } from '../panel/panel.module';

import { RetraitPageRoutingModule } from './retrait-routing.module';

@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule,
    SuperTabsModule,
    PanelComponentModule,
    DynamicModule,
    RetraitPageRoutingModule
  ],
  declarations: [RetraitPage]
})
export class RetraitPageModule {}
