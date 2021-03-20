import { FieldConfig } from 'src/model/field.interface';
import {  Component, EventEmitter, Input, OnChanges, OnInit, Output } from '@angular/core';
import { FormGroup, FormBuilder, Validators, FormControl } from "@angular/forms";

@Component({
  selector: 'app-dynamic-form',
  templateUrl: './dynamic-form.component.html',
  styleUrls: ['./dynamic-form.component.scss'],
})
export class DynamicFormComponent implements OnInit {
@Input() fields: FieldConfig[] = [];

@Output() submitClick: EventEmitter<any> = new EventEmitter<any>();
form: FormGroup;

  constructor(private fb: FormBuilder) { }

  ngOnInit() {
    this.form = this.createControl();
  }
  get value(): any {
    return this.form.value;
  }

  createControl(){
    const group = this.fb.group({});

    this.fields.forEach(field => {
      if (field.type === 'button') {return; }
      const control = this.fb.control(
        field.value,
        this.bindValidations(field.validations || [])
      );
      group.addControl(field.name, control);
    });

    return group;
  }
  bindValidations(validations: any) {
    if (validations.length > 0){
      const validList = [];
      validations.forEach(valid => {
        validList.push(valid.validator);
      });
      return Validators.compose(validList);
    }
    return null;
  }

  validateAllFormFields(formGroup: FormGroup){
    Object.keys(formGroup.controls).forEach( field => {
      const control = formGroup.get(field);
      control.markAsTouched({ onlySelf: true});
    });
  }
  onSubmit(event: Event) {
    event.preventDefault();
    event.stopPropagation();
    if (this.form.valid) {
      this.submitClick.emit(this.form.value);
    }
    else {
      this.validateAllFormFields(this.form);
    }
  }

}
