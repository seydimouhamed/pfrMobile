import { DynamicFormComponent } from './dynamic-form/dynamic-form.component';
import { DynamicFieldDirective } from './dynamic-field/dynamic-field.directive';
import { DynamicFieldComponent } from './dynamic-field/dynamic-field.component';
import { SelectComponent } from './select/select.component';
import { IonicModule } from '@ionic/angular';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ButtonComponent } from './button/button/button.component';
import { InputComponent } from './input/input.component';

const modules = [
  ButtonComponent,
  InputComponent,
  SelectComponent,
  DynamicFieldComponent,
  DynamicFieldDirective,
DynamicFormComponent
];

@NgModule({
  declarations: [
    modules
 ],
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    IonicModule,
  ]
  ,
  exports: [
    modules
  ]
})
export class DynamicModule { }
