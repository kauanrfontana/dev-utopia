import { NgModule } from "@angular/core";
import { CommonModule } from "@angular/common";
import { SharedComponent } from "./shared.component";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";

@NgModule({
  declarations: [SharedComponent],
  imports: [FormsModule, ReactiveFormsModule],
  providers: [],
  exports: [FormsModule, ReactiveFormsModule],
})
export class SharedModule {}
