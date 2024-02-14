import { NgModule } from "@angular/core";
import { SharedComponent } from "./shared.component";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { RequiredDirective } from "./Required/Required.directive";
import { MatIconModule } from "@angular/material/icon";

@NgModule({
  declarations: [SharedComponent, RequiredDirective],
  imports: [FormsModule, ReactiveFormsModule, MatIconModule],
  providers: [],
  exports: [FormsModule, ReactiveFormsModule, RequiredDirective, MatIconModule],
})
export class SharedModule {}
