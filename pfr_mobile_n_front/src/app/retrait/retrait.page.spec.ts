import { ComponentFixture, TestBed, waitForAsync } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';
import { PanelComponentModule } from '../panel/panel.module';

import { RetraitPage } from './retrait.page';

describe('Tab2Page', () => {
  let component: RetraitPage;
  let fixture: ComponentFixture<RetraitPage>;

  beforeEach(waitForAsync(() => {
    TestBed.configureTestingModule({
      declarations: [RetraitPage],
      imports: [IonicModule.forRoot(), PanelComponentModule]
    }).compileComponents();

    fixture = TestBed.createComponent(RetraitPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
