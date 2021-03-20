import { ComponentFactoryResolver,
  ComponentRef,
  Directive, Input, OnInit,
  ViewContainerRef } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { ButtonComponent } from '../button/button/button.component';
import { SelectComponent } from '../select/select.component';
import { InputComponent } from '../input/input/input.component';
import { FieldConfig } from 'src/model/field.interface';


const componentMapper = {
  input: InputComponent,
  button: ButtonComponent,
  select: SelectComponent
  };

@Directive({
  selector: '[appDynamicField]'
})
export class DynamicFieldDirective implements OnInit{
@Input() field: FieldConfig;
@Input() group: FormGroup;


componentRef: any;
  constructor(
    private resolver: ComponentFactoryResolver,
    private container: ViewContainerRef
  ) { }

  ngOnInit(): void {
    const factory = this.resolver.resolveComponentFactory(componentMapper[this.field.type]);
    this.componentRef = this.container.createComponent(factory);
    this.componentRef.instance.field = this.field;
    this.componentRef.instance.group = this.group;
  }
}
