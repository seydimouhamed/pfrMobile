import { Component, OnInit } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { FieldConfig } from 'src/model/field.interface';

@Component({
  selector: 'app-input',
  template: '',
  styleUrls: [],
})
export class InputComponent implements OnInit {
 field: FieldConfig;
 group: FormGroup

  constructor() { }

  ngOnInit() {}

}
